"use client";

import { useEffect, useState } from "react";
import { GoalColumn } from "./GoalColumn";
import { Button } from "@/components/ui/button";
import { AddGoalModal } from "@/components/forms/AddGoalModal";
import { useGoals } from "@/hooks/useGoals";
import { usePersistentGoals } from "@/hooks/usePersistentGoals";
import { filterGoalsByStatus } from "@/lib/goals";
import { Plus } from "lucide-react";

interface DashboardLayoutProps {
  onAddGoalClick?: () => void;
  onModalOpen?: (isOpen: boolean) => void;
}

/**
 * Main dashboard layout component
 * Manages app state, handles goal operations, and renders both columns with modal
 */
export function DashboardLayout({
  onAddGoalClick,
  onModalOpen,
}: DashboardLayoutProps) {
  const { goals: persistedGoals, isLoading } = usePersistentGoals();
  const {
    goals,
    addGoal: hookAddGoal,
    completeGoal,
    deleteGoal,
  } = useGoals(persistedGoals);
  
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [formError, setFormError] = useState<string | null>(null);

  // Handle add goal form submission
  const handleAddGoal = (title: string, endDate: string) => {
    const result = hookAddGoal(title, endDate);
    
    if (!result.success) {
      setFormError(result.error || "Failed to add goal");
      return;
    }

    // Close modal on success
    setIsModalOpen(false);
    setFormError(null);
  };

  // Handle modal state changes
  const handleOpenModal = () => {
    setIsModalOpen(true);
    setFormError(null);
    onModalOpen?.(true);
  };

  const handleCloseModal = () => {
    setIsModalOpen(false);
    setFormError(null);
    onModalOpen?.(false);
  };

  // Expose modal state for parent or other consumers
  useEffect(() => {
    onAddGoalClick?.();
  }, [onAddGoalClick]);

  // Filter goals by status
  const currentGoals = filterGoalsByStatus(goals, "current");
  const completedGoals = filterGoalsByStatus(goals, "completed");

  // Show loading state
  if (isLoading) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <p className="text-gray-500">Loading your goals...</p>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gray-50 p-4 md:p-8">
      <div className="max-w-6xl mx-auto">
        {/* Header */}
        <div className="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
          <div>
            <h1 className="text-4xl font-bold text-gray-900">DoIt</h1>
            <p className="text-gray-600 mt-1">Goal Tracker</p>
          </div>

          {/* Add Goal button */}
          <Button
            onClick={handleOpenModal}
            variant="default"
            className="bg-pastel-mint hover:bg-pastel-mint/80 text-gray-900 min-h-11 px-6 gap-2"
          >
            <Plus className="h-5 w-5" />
            Add Goal
          </Button>
        </div>

        {/* Two-column dashboard layout */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
          {/* Current Goals column */}
          <GoalColumn
            title="Current Goals"
            goals={currentGoals}
            onCompleteGoal={completeGoal}
            onDeleteGoal={deleteGoal}
          />

          {/* Completed Goals column */}
          <GoalColumn
            title="Completed Goals"
            goals={completedGoals}
            onCompleteGoal={completeGoal}
            onDeleteGoal={deleteGoal}
          />
        </div>
      </div>

      {/* Add Goal Modal */}
      <AddGoalModal
        isOpen={isModalOpen}
        onClose={handleCloseModal}
        onSubmit={handleAddGoal}
      />

      {/* Error message display if form submission fails */}
      {formError && (
        <div className="fixed bottom-4 right-4 bg-red-50 border border-red-200 rounded-lg p-4 max-w-sm">
          <p className="text-red-800 text-sm">{formError}</p>
        </div>
      )}
    </div>
  );
}
