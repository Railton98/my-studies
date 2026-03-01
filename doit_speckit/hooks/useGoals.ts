/**
 * Custom hook for goal management
 * Provides methods to add, complete, and delete goals with validation
 */

import {
    createGoal,
    isDuplicateGoal,
    isValidEndDate,
} from "@/lib/goals";
import { saveGoals } from "@/lib/storage";
import { Goal } from "@/types/goal";
import { useCallback, useState } from "react";

interface UseGoalsReturn {
  goals: Goal[];
  addGoal: (title: string, endDate: string) => { success: boolean; error?: string };
  completeGoal: (id: string) => void;
  deleteGoal: (id: string) => void;
}

/**
 * Hook to manage goals with validation and persistence
 * @param initialGoals - Initial goals array to start with
 * @returns Object with goals array and action methods
 */
export function useGoals(initialGoals: Goal[] = []): UseGoalsReturn {
  const [goals, setGoals] = useState<Goal[]>(initialGoals);

  // Add a new goal with validation
  const addGoal = useCallback(
    (title: string, endDate: string): { success: boolean; error?: string } => {
      // Validate title
      if (!title || title.trim() === "") {
        return { success: false, error: "Title is required" };
      }

      // Validate end date
      if (!endDate) {
        return { success: false, error: "End date is required" };
      }

      // Check if end date is in the future or today
      if (!isValidEndDate(endDate)) {
        return { success: false, error: "End date must be today or in the future" };
      }

      // Check for duplicates
      if (isDuplicateGoal(goals, title, endDate)) {
        return { success: false, error: "Goal already exists" };
      }

      // Create and add new goal
      const newGoal = createGoal(title, endDate);
      const updatedGoals = [...goals, newGoal];
      setGoals(updatedGoals);
      saveGoals(updatedGoals);

      return { success: true };
    },
    [goals]
  );

  // Mark goal as completed
  const completeGoal = useCallback((id: string) => {
    setGoals((prevGoals) => {
      const updatedGoals = prevGoals.map((goal) =>
        goal.id === id ? { ...goal, status: "completed" as const } : goal
      );
      saveGoals(updatedGoals);
      return updatedGoals;
    });
  }, []);

  // Delete a goal
  const deleteGoal = useCallback((id: string) => {
    setGoals((prevGoals) => {
      const updatedGoals = prevGoals.filter((goal) => goal.id !== id);
      saveGoals(updatedGoals);
      return updatedGoals;
    });
  }, []);

  return {
    goals,
    addGoal,
    completeGoal,
    deleteGoal,
  };
}
