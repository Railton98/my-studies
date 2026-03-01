/**
 * Goal business logic and validation functions
 * Handles goal creation, validation, and filtering
 */

import { Goal } from "@/types/goal";
import { getDaysRemaining } from "./dates";

/**
 * Generate a unique ID using timestamp and random number
 * @returns Unique ID string
 */
function generateId(): string {
  return `${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
}

/**
 * Create a new goal with unique ID and current timestamp
 * @param title - Goal title
 * @param endDate - Goal end date (ISO string YYYY-MM-DD)
 * @returns New Goal object
 */
export function createGoal(title: string, endDate: string): Goal {
  return {
    id: generateId(),
    title,
    endDate,
    status: "current",
    createdAt: new Date().toISOString(),
  };
}

/**
 * Check if a goal with the same title and date already exists
 * @param goals - Array of existing goals
 * @param title - Goal title to check
 * @param endDate - Goal end date to check
 * @returns true if duplicate exists
 */
export function isDuplicateGoal(
  goals: Goal[],
  title: string,
  endDate: string
): boolean {
  return goals.some(
    (goal) =>
      goal.title.toLowerCase() === title.toLowerCase() &&
      goal.endDate === endDate &&
      goal.status === "current"
  );
}

/**
 * Validate that the end date is not in the past
 * @param endDate - Goal end date (ISO string YYYY-MM-DD)
 * @returns true if date is valid (today or future)
 */
export function isValidEndDate(endDate: string): boolean {
  const daysRemaining = getDaysRemaining(endDate);
  return daysRemaining >= 0; // Today or future
}

/**
 * Filter goals by status
 * @param goals - Array of goals
 * @param status - Status to filter by ("current" or "completed")
 * @returns Filtered array of goals
 */
export function filterGoalsByStatus(
  goals: Goal[],
  status: "current" | "completed"
): Goal[] {
  return goals.filter((goal) => goal.status === status);
}
